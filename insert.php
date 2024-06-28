<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
$name = $_POST['name'];
$email = $_POST['email'];
$content = $_POST['content'];


//2. DBに接続します
try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=gs_db_class;charset=utf8;host=localhost','root','');  //後ろの2つは、XAMPPのIDとPIN(今は無し)
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成（実行したいSQLを書く）
$stmt = $pdo->prepare('INSERT INTO 
                gs_an_table(id, name, email, content, date) 
                VALUES(NULL, :name, :email, :content, now())
                ');

//  2. バインド変数を用意
// Integer は、数値の場合 PDO::PARAM_INT
// String は、文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //PDO::PARAM_STRは、このパラメータをDB側では文字列型のデータとして受け取ってもらうように設定すること
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();


//４．データ登録処理後（つまり実行したらどうする）
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);

}else{
  //５．index.phpへリダイレクト
  header('Location: index.php');
}
?>
