<?php

use think\facade\Route;

Route::get('portal/categories$', 'portal/Categories/index');
Route::get('portal/categories/:id$', 'portal/Categories/read');
Route::get('portal/subcategories/[:id]$', 'portal/Categories/subCategories');
Route::get('portal/tags/:id/articles$', 'portal/Tags/articles');
Route::get('portal/tags$', 'portal/Tags/index');
Route::get('portal/tags/hot$', 'portal/Tags/hotTags');
Route::get('portal/articles$', 'portal/Articles/index');
Route::get('portal/articles/recommended$', 'portal/Lists/recommended');
Route::get('portal/articles/my$', 'portal/UserArticles/index');
Route::get('portal/articles/:id$', 'portal/Articles/read');
Route::get('portal/articles/search/:keyword$', 'portal/Articles/search');
Route::get('portal/articles/category/:id$', 'portal/Lists/getCategoryPostLists');
Route::get('portal/articles/:id/related$', 'portal/Articles/relatedArticles');
Route::get('portal/articles/user/:id$', 'portal/Articles/user');
Route::post('portal/articles/like/do$', 'portal/Articles/doLike');
Route::post('portal/articles/like/cancel$', 'portal/Articles/cancelLike');
Route::post('portal/articles/favorite/do$', 'portal/Articles/doFavorite');
Route::post('portal/articles/favorite/cancel$', 'portal/Articles/cancelFavorite');
Route::get('portal/pages$', 'portal/Pages/index');
Route::get('portal/pages/:id$', 'portal/Pages/read');
Route::get('portal/user/articles$', 'portal/UserArticles/index');
Route::get('portal/user/articles/:id$', 'portal/UserArticles/read');
Route::post('portal/user/articles$', 'portal/UserArticles/save');
Route::put('portal/user/articles/deletes$', 'portal/UserArticles/deletes');
Route::put('portal/user/articles/:id$', 'portal/UserArticles/update');
Route::delete('portal/user/articles/:id$', 'portal/UserArticles/delete');

Route::get('portal/search', 'portal/Articles/search');
Route::get('portal/articles/relatedArticles', 'portal/Articles/relatedArticles');
Route::post('portal/articles/doLike', 'portal/Articles/doLike');
Route::post('portal/articles/cancelLike', 'portal/Articles/cancelLike');
Route::post('portal/articles/doFavorite', 'portal/Articles/doFavorite');
Route::post('portal/articles/cancelFavorite', 'portal/Articles/cancelFavorite');
Route::get('portal/tags/:id/articles', 'portal/Tags/articles');
Route::get('portal/tags', 'portal/Tags/index');
Route::get('portal/tags/hotTags', 'portal/Tags/hotTags');
