<?php

use Illuminate\Support\Facades\Route;
use App\Models\Document;
use SyntheticComments\Models\Comment;
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

Route::get('/', function () {
    return view('welcome');
});
// Revisions
//**** Insert */
Route::get('/doc', function () {
    $doc = new Document();
    $doc->name = "HUssssain";
    $doc->description = "rdhfhrtytr";
    $doc->user_id = 1;
    $doc->save();
    return "dfg works";
});
Route::get('/getrevisions', function () {
    return Document::find('654c854a9c75a1dfab0df11a')->revisions()->limit(1)->get()->compare(Document::class);
});
// Comment
//**** Insert */
Route::get('/comment', function () {
    $data = [
        'body' => 'Reolay dimu nah',
        'type' => 'default',
        'resource' => 'App\Models\Document',
        'resource_id' => '6527d48a6ee71db0df06c123',
        'parent_comment_id' => '654c99829c75a1dfab0df11f',
        'visibility' => '[user_id:[1,2,3]]',
        'user_id' => 1
    ];
    $comment = new Comment();
    return $comment->storeComment($data);
});

// Retrieve Data
Route::get('/getcomments', function () {
    // return Document::find('6527d48a6ee71db0df06c123');
    $doc = Document::find('654c806491af254ffe02a0a3');
    return $doc->comments();
    $comment = Comment::find('654c9e4b9c75a1dfab0df121');
    return $relatedModel = $comment->getRelatedModelComments();
});
