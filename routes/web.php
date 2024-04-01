<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\EstatisticaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('root');
Route::get('home', [HomeController::class, 'index'])->name('root');
Route::get('catalogo', [TshirtImageController::class, 'index'])->name('catalogo');
Route::get('perfil/editar', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('perfil', [CustomerController::class, 'update'])->name('customer.update');
Route::get('perfil', [CustomerController::class, 'show'])->name('customer.show');
Route::post('/user/{user}/update-photo', [UserController::class, 'updatePhoto'])->name('user.updatePhoto');
Route::delete('/user/{user}/remove-photo', [UserController::class, 'removePhoto'])->name('user.remove_photo');
Route::get('utilizadores', [UserController::class, 'index'])->name('user.index');
Route::get('utilizadores/criar', [UserController::class, 'create'])->name('user.create');
Route::post('utilizadores', [UserController::class, 'store'])->name('user.store');
Route::get('/utilizadores/{user}', [UserController::class, 'show'])->name('user.show');
Route::put('/utilizadores/{user}', [UserController::class, 'update'])->name('user.update');
Route::get('/utilizadores/editar/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::get('/utilizadores/block/{user}', [UserController::class, 'changeBlock'])->name('user.changeBlock');
Route::delete('/utilizadores/remove/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/utilizadores/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
Route::get('/catalogo/criar', [TshirtImageController::class, 'create'])->name('tshirtImage.create')->middleware('notEmployee');
Route::post('/catalogo', [TshirtImageController::class, 'store'])->name('tshirtImage.store');
Route::get('/categoria/criar', [CategorieController::class, 'create'])->name('categorie.create');
Route::post('/categoria', [CategorieController::class, 'store'])->name('categorie.store');
Route::get('/categoria', [CategorieController::class, 'index'])->name('categorie.index');
Route::delete('/categoria/remove/{tshirtImage}', [TshirtImageController::class, 'destroy'])->name('tshirtImage.destroy');
Route::get('/categoria/restore/{id}', [TshirtImageController::class, 'restore'])->name('tshirtImage.restore');
Route::get('cores',[ColorController::class, 'index'])->name('color.index');
Route::get('cores/criar',[ColorController::class, 'create'])->name('color.create');
Route::post('cores', [ColorController::class, 'store'])->name('color.store');
Route::delete('/cores/remove/{code}', [ColorController::class, 'destroy'])->name('color.destroy');
Route::get('/cores/restore/{code}', [ColorController::class, 'restore'])->name('color.restore');
Route::put('/cores/{color}', [ColorController::class, 'update'])->name('color.update');
Route::get('/cores/editar/{color}', [ColorController::class, 'edit'])->name('color.edit');
Route::post('carrinho/adicionar', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('carrinho/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('carrinho', [CartController::class, 'show'])->name('cart.show');
Route::post('carrinho', [CartController::class, 'store'])->name('cart.store')->middleware('auth')->middleware('customer');
Route::delete('carrinho', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/image/editar/{tshirtImage}', [TshirtImageController::class, 'edit'])->name('tshirtImage.edit');
Route::put('/catalogo/{tshirtImage}', [TshirtImageController::class, 'update'])->name('tshirtImage.update');
Route::post('orderItem', [OrderItemController::class, 'store'])->name('orderItem.store');
Route::get('encomendas', [OrderController::class, 'index'])->name('order.index');
Route::get('encomendas/my', [OrderController::class, 'show'])->name('order.show');
Route::get('encomenda/{orderId}/{status}', [OrderController::class, 'mudarEstado'])->name('order.mudarEstado');
Route::get('cancelar/encomenda/{orderId}', [OrderController::class, 'cancel'])->name('order.cancel');
Route::get('editar/preco', [PriceController::class, 'edit'])->name('price.edit');
Route::put('editar/preco',[PriceController::class, 'update'])->name('price.update');
Route::get('minhas/imagens', [TshirtImageController::class, 'indexOwn'])->name('tshirtImage.indexOwn');
Route::post('minhas/imagens', [TshirtImageController::class, 'storeOwn'])->name('tshirtImage.storeOwn');
Route::get('image/{tshirtImage}', [TshirtImageController::class, 'getPrivateImage'])->name('tshirtImage.getPrivateImage');
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
Route::get('/pdf/{filename}', [PDFController::class, 'show'])->name('pdf.show');
Route::get('/estatisticas', [EstatisticaController::class, 'index'])->name('estatisticas.index');
Route::delete('minhas/imagens/{id}', [TshirtImageController::class, 'destroyOwn'])->name('tshirtImage.destroyOwn');
Route::put('minhas/imagens/{tshirtImage}', [TshirtImageController::class, 'updateOwn'])->name('tshirtImage.updateOwn');
Route::delete('categoria/eliminar/{id}', [CategorieController::class, 'destroy'])->name('categorie.destroy');









Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


