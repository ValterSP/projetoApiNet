@php
    $tipoUtilizador = $user_type;
@endphp
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdowns = document.querySelectorAll(".dropdown");

        dropdowns.forEach(function(dropdown) {
            const content = dropdown.nextElementSibling;

            dropdown.addEventListener("click", function() {
                const isActive = dropdown.classList.contains("active");
                const activeDropdown = document.querySelector(".dropdown.active");
                if (activeDropdown && activeDropdown !== dropdown) {
                    activeDropdown.classList.remove("active");
                    activeDropdown.nextElementSibling.style.display = "none";
                }
                dropdown.classList.toggle("active");
                content.style.display = dropdown.classList.contains("active") ? "block" :
                    "none";
            });
        });
    });
</script>

<div class="table-container">
    <table>
        <thead>
        <tr>
            <th>Data</th>
            <th>Notas</th>
            <th>Morada</th>
            <th>Tipo Pagamento</th>
            <th>Ref Pagamento</th>
            <th>Preço Total</th>
            <th>Estado</th>
            @if($tipoUtilizador != 'C')
                <th>Mudar estado</th>
            @endif
            @if($tipoUtilizador != 'E')
                <th>Fatura</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($encomendas as $encomenda)
            <tr class="dropdown clickable">
                <td>{{ $encomenda->date }}</td>
                <td>{{ $encomenda->notes }}</td>
                <td>{{ $encomenda->address }}</td>
                <td>{{ $encomenda->payment_type }}</td>
                <td>{{ $encomenda->payment_ref }}</td>
                <td>{{ $encomenda->total_price }}€</td>
                <td>
                    @switch($encomenda->status)
                        @case('pending')
                            <span class="pendente"> PENDENTE</span>
                            @break

                        @case('paid')
                            <span class="pago"> PAGO </span>
                            @break

                        @case('closed')
                            <span class="fechado"> FECHADO </span>
                            @break

                        @case('canceled')
                            <span class="cancelado">CANCELADO</span>
                            @break
                    @endswitch
                </td>
                @if($tipoUtilizador != 'C')
                    <td style="cursor: default">
                        @if ($encomenda->status == 'pending')
                            <form
                                action="{{ route('order.mudarEstado', ['orderId' => $encomenda, 'status' => 'paid']) }}"
                                method="GET" style="display: inline;">
                                <button type="submit" class="btn btn-success btn-icon">
                                    <i class="fa-solid fa-money-bill-wave"></i><i
                                        class="fa-regular fa-circle-check btn-icon-right"></i>
                                </button>
                            </form>
                        @endif
                        @if ($encomenda->status == 'paid')
                            <form
                                action="{{ route('order.mudarEstado', ['orderId' => $encomenda, 'status' => 'closed']) }}"
                                method="GET" style="display: inline;">
                                <button type="submit" class="btn btn-secondary btn-icon">
                                    <i class="fa-solid fa-box"></i><i class="fa fa-lock btn-icon-right"></i>
                                </button>
                            </form>
                        @endif
                        @if ($tipoUtilizador == 'A' && $encomenda->status != 'canceled')
                            <form action="{{ route('order.cancel', ['orderId' => $encomenda]) }}" method="GET"
                                  style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-icon">
                                    <i class="fa-solid fa-box"></i><i class="fa fa-ban btn-icon-right"
                                                                      aria-hidden="true"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                @endif

                    @if($tipoUtilizador != 'E')
                    <td>
                        @if(!is_null($encomenda->receipt_url))
                            <a href="{{route('pdf.show', $encomenda->receipt_url)}}" target="_blank" class="btn btn-dark"><i
                                    class="fas fa-eye"></i>
                                @else
                                    <p>Sem Fatura</p>
                        @endif
                    </td>
                    @endif

            </tr>
            <tr class="dropdown-content orderItems">
                <td>
                    <table class="order-details-table">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Tamanho</th>
                            <th>Quantidade</th>
                            <th>Sub-Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($encomenda->orderItem as $item)
                            <tr>
                                <td>
                                    <div class="tshirtEstampa">
                                        <img src="{{ asset('storage/tshirt_base/' . $item['color_code'] . '.jpg') }}" alt="">
                                        @if(!Storage::disk('tshirt_images_private')->exists($item->tshirtImage->image_url))
                                            <img src="{{ asset('storage/tshirt_images/' . $item->tshirtImage->image_url) }}" alt=""
                                                 class="estampa">
                                        @else
                                            <img src="data:image/png;base64, {{ base64_encode(Storage::disk('tshirt_images_private')->get($item->tshirtImage->image_url)) }}" alt="" class="estampa">
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->size }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->sub_total }}€</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-container">
        {{ $encomendas->withQueryString()->links() }}
    </div>
</div>
