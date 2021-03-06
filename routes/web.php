<?php

use Illuminate\Support\Facades\Route;

Route::get('markdown', function () {
    $text =<<<EOT
테스트
문법
마크다운쓰
## 순서없는목록
- 가나다라
- 마바[^1]
EOT;
    
    return app(ParsedownExtra::class)->text($text);

});

Route::get('/', 'WelcomeController@index');
/*Route::get('/', function() {
    return redirect('login');
});*/

Route::get('auth/login', function () {
    $credentials = [
        'email'    => 'jaewoo@naver.com',
        'password' => 'password'
    ];

    if (!auth()->attempt($credentials)) {
        return '로그인 정보가 정확하지 않습니다.';
    }

    return redirect('protected');
});

Route::get('protected', ['middleware' => 'auth', function () {
    dump(session()->all());

    return '어서 오세요' . auth()->user()->name;
}]);

Route::get('logout', function () {
    auth()->logout();

    return '또 봐요ㅎㅎ';
});

Route::resource('articles', 'ArticlesController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('docs/{file?}', 'DocsController@show');

Route::get('docs/images/{image}', 'DocsController@image')
    ->where('image', '{\pl-\pN\._~}+-img-[0-9]{2}.png');

