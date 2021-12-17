<?php

$msgs = explode("\n", file_get_contents("messages.txt"));
$question = $_POST['question'];

$people = file_get_contents("people.json");
$decodedPeople = json_decode($people,true);

if($_POST['person'] == ""){
    $en_name = array_rand($decodedPeople);
    $msg = 'سوال خود را بپرس!';
}
else
{
    $en_name = $_POST['person'];
    $msg = $msgs[hexdec(substr(sha1($question . $en_name), 0, 6)) % count($msgs)];
    //امتیازی
    if((substr($question,-1) != "?" && substr($question,-2) !="؟") || substr($question,0 ,6) != "آیا"){
        $msg = "سوال درستی پرسیده نشده!" ;
    }
}
$fa_name = $decodedPeople[$en_name];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <?php if($question != ""){
        echo '<span id="label">پرسش:</span>';
        }?>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                foreach($decodedPeople as $key => $value){
                    if($key == $en_name)
                        echo '<option value='.$key.' selected>'.$value.'</option>';
                    else
                        echo '<option value='.$key.'>'.$value.'</option>';
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>