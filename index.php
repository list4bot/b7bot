<?php
require_once 'config.php';
require_once 'main.class.php';

//-----------
$BOT = new Main();
$db = mysqli_connect($Host, $UserName, $PassWord, $DBName);

//Updates
$update = file_get_contents("php://input");
$updateData = json_decode($update,true);
$messageData = isset($updateData["callback_query"]) ? $updateData["callback_query"] : $updateData["message"];
$messageTime = $messageData["date"];


$chatId = isset($updateData["callback_query"]) ? $updateData["callback_query"]["message"]["chat"]["id"] : $updateData["message"]["chat"]["id"];
$chatName = isset($updateData["callback_query"]) ? $updateData["callback_query"]["message"]["chat"]["title"] : $updateData["message"]["chat"]["title"];
$chatType = isset($updateData["callback_query"]) ? $updateData["callback_query"]["message"]["chat"]["type"] : $updateData["message"]["chat"]["type"];

$messageId = isset($updateData["callback_query"]) ? $updateData["callback_query"]["message"]["message_id"] : $updateData["message"]["message_id"];

$messageText = $messageData["text"];

$reply = $messageData["reply_to_message"];
$replyID = $messageData["reply_to_message"]["from"]["id"];

$data = $updateData["callback_query"]["data"];
$from_id = $messageData["from"]["id"];
$from_name = $messageData["from"]["first_name"] . $messageData["from"]["last_name"];
$from_username = $messageData["from"]["username"];

$inlineqt = $updateData['inline_query']['query'];
$inlineid = $updateData['inline_query']['id'];
$from_idinline = $updateData['inline_query']['from']['id'];
$from_nameinline =  $updateData['inline_query']['from']["first_name"] .  $updateData['inline_query']["from"]["last_name"];
$from_usernameinline = $updateData['inline_query']['from']['username'];

//End Updates

if(!isset($updateData['inline_query'])){
@$fetch = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `users` WHERE `from_id` ='$from_id'"));
if(!$fetch and isset($updateData)){
$Rand = $BOT->RandomString($from_id);
if($from_username != ""){
$username = $from_username;
$is_username = 1;
}else {
$username = $from_name;
$is_username = 0;
}
$username = base64_encode($username);

mysqli_query($db,"INSERT INTO users(from_id, username, is_username, foreignkey, banlist, step) VALUES ('$from_id', '$username', '$is_username', '$Rand', '', '')");
}
}else{
@$fetch = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `users` WHERE `from_id` ='$from_idinline'"));
if(!$fetch and isset($updateData)){
$Rand = $BOT->RandomString($from_idinline);
if($from_usernameinline != ""){
$username = $from_usernameinline;
$is_username = 1;
}else {
$username = $from_nameinline;
$is_username = 0;
}
$username = base64_encode($username);

mysqli_query($db,"INSERT INTO users(from_id, username, is_username, foreignkey, banlist, step) VALUES ('$from_idinline', '$username', '$is_username', '$Rand', '', '')");
}
}


if(preg_match("/^\/([Ss]tart)/s",$messageText) and !preg_match("/^\/(start) (.*)/s",$messageText)){
if($from_username != ""){
$Url = "[@$from_username](t.me/$from_username)";
}else {
$Url = "[$from_name](t.me/$Channel)";
}
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
   'text'=>"اهلاً بك: $Url

▪️ بوت صارحني

▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

🌐 احصل على الرابط الخاص بك .
💌 إقرأ ما كتبه الناس عنك .
⚙️ أوامر البوت - /help
-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💡 عن بوت صارحني",'callback_data'=>"About"],
                        ],
                                            [
                        ['text'=>"🌐 إنشاء رابط خاص",'callback_data'=>"Link"],
                        ]
                ]
            ])
]);
}
if($messageText == "/help" ){
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
   'text'=>"
بعض الإوامر الخاصك بك:

▫️/ban -  مع الرد على الرسالة  - حظر
▫️/unban  - مع الرد على الرسالة - رفع الحظر

-",
]);
}
if($data == "Home"){
if($from_username != ""){
$Url = "[@$from_username](t.me/$from_username)";
}else {
$Url = "[$from_name](t.me/$Channel)";
}
   $BOT->sendCommand('editMessageText',[
   'chat_id'=>$chatId,
    'message_id'=>$messageId,
   'text'=>"اهلاً بك: $Url

▪️ بوت صارحني

▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

🌐 احصل على الرابط الخاص بك .
💌 إقرأ ما كتبه الناس عنك .
⚙️ أوامر البوت - /help
-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💡 عن بوت صارحني",'callback_data'=>"About"],
                        ],
                                            [
                        ['text'=>"🌐 إنشاء رابط خاص",'callback_data'=>"Link"],
                        ]
                ]
            ])
]);    
}
if($data == "About"){
   $BOT->sendCommand('editMessageText',[
   'chat_id'=>$chatId,
    'message_id'=>$messageId,
   'text'=>"📩 بوت صارحني
▫️صارحني لتلقي النقد البناء بسرية تامة لتنمية الذات مع الحفاظ على سرية هوية المرسل وخصوصية الرسائل

▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

▪️ الفائدة .
▫️عزز نقاط القوة لديك
▫️عالج نقاط ضعفك
▫️عزز صداقاتك بمعرفة مزاياك وعيوبك
▫️مكّن أصحابك من مصارحتك

📱 يتيح لك بوت صارحني مشاركة الرابط والرد على الرسائل بسهولة وحظر المستخدمين المزعجين

🔘 هل أنت مستعد لمعرفة ملاحظات الناس عنك بدون أن تعرفهم ؟
-",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"🔙 رجوع ...",'callback_data'=>"Home"],
                        ],
                ]
            ])
        ]);
}
if($data == "Link"){
$Link = $fetch['foreignkey'];
   $BOT->sendCommand('editMessageText',[
   'chat_id'=>$chatId,
    'message_id'=>$messageId,
   'text'=>"▪️ الرابط الخاص بك .

▫️ http://t.me/$UserNameBot?start=$Link

▫️ يمكنك نشر الرابط في قروبات التيليجرام او بين أصدقائك او مواقع التواصل الإجتماعي.

▪️حانت لحظة الصراحة .
-",
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                                    [
                        ['text'=>"🌐 مشاركة الرابط",'switch_inline_query'=>" "],
                        ],
                    [
                        ['text'=>"🔙 رجوع ...",'callback_data'=>"Home"],
                        ],
                ]
            ])
        ]);
}

if($data == "exit"){
mysqli_query($db,"UPDATE users SET step='' WHERE from_id='$from_id'");
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
   'text'=>"✅ تم الغاء الارسال .
▫️ لن يمكنك إرسال اي رسالة الان .
▫️ اذا كنت تريد معاودة الإرسال ادخل من الرابط مره أخرى لنفس العضو.
-",
]);
}

if($messageText== "/stats"){
$result = mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(*) AS `count` FROM `users`"));
$result = $result['count'];
$resultn = mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(*) AS `count` FROM `messages`"));
$resultn = $resultn['count'];
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
     'reply_to_message_id'=>$messageId,
   'text'=>"*Stats*:-\n Users:$result\n Messages:$resultn",
   'parse_mode'=>"Markdown"
]);
}


if(!$reply and preg_match("/^(send)_(.*)/s",$fetch['step']) and $fetch['step'] != "" and !$data){
if($messageText){
if($messageText != "/help" and $messageText != "/ban" and $messageText != "/unban" and $messageText != "/stats" and $messageText != "/start" and !preg_match("/^\/(start) (.*)/s",$messageText)){
preg_match("/^(send)_(.*)/s",$fetch['step'],$matcha);
$from_id_two = $matcha[2];
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
   'text'=>"✅ تم إرسال رسالتك بنجاح .",
   'parse_mode'=>"Markdown"
  ]);
  $data = date("Y/m/d h:i");
  $out = $BOT->sendCommand('sendmessage',[
    'chat_id'=>$from_id_two,
   'text'=>"💌 وصلت لك رسالة جديدة
⏱وقت الرسالة: $data $timee
✉️ المحتوى :  ↓↓
$messageText
----
💡يمكنك الرد بعمل رد على هذه الرسالة .",
   'parse_mode'=>"Markdown"
  ]);
$out = json_decode($out);
$out = $out->result->message_id;
mysqli_query($db,"INSERT INTO messages(from_id_one, message_id_one, from_id_two, message_id_two) VALUES ('$from_id', '$messageId', '$from_id_two', '$out')");
}
}else{
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
   'text'=>"يمكنك ارسال الرسائل النصية فقط في الوقت الحالي.",
   'parse_mode'=>"Markdown"
  ]);
}
}
if ($reply && $messageText== "/ban") {
$msgid = $reply['message_id'];
$GetDB = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `messages` WHERE `from_id_two` ='$from_id' AND `message_id_two` ='$msgid'"));

$check = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `users` WHERE `from_id` ='".$GetDB['from_id_one']."'"));
$check = $check['step'];
$check = preg_match("/^(send)_(.*)/s",$check,$matcha);
$check = $matcha[2];
if($GetDB and $check == $from_id){

$banlist = $fetch['banlist'];
if($banlist == ""){
$saveend = $GetDB['from_id_one'];
}else {
$saveend = $banlist.",".$GetDB['from_id_one'];
}
    
mysqli_query($db,"UPDATE users SET banlist='$saveend' WHERE from_id='$from_id'");

$BOT->sendCommand('sendMessage',[
    'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
    'text'=>"🛡 تم حظر صاحب هذه الرسالة.",
]);
mysqli_query($db,"UPDATE users SET step='' WHERE from_id='".$GetDB['from_id_one']."'");
$BOT->sendCommand('sendMessage',[
'chat_id'=>$GetDB['from_id_one'],
    'text'=>"▪️ تم حظرك .

▫️وتم اغلاق إرسال الرسائل تلقائياً",
]);



}else {
$BOT->sendCommand('sendMessage',[
    'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
    'text'=>"▫️عفواً لا يمكنك حظر هذا الشخص

▪️لأنه قام بأغلاق إرسال الرسائل الخاصة بالصراحه",
]);
}
}
if($reply and $messageText == "/unban"){
$msgid = $reply['message_id'];
$GetDB = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `messages` WHERE `from_id_two` ='$from_id' AND `message_id_two` ='$msgid'"));
if($GetDB){

$banlist = $fetch['banlist'];
$saveend = str_replace(",".$GetDB['from_id_one'],'',$banlist);
$saveend = str_replace($GetDB['from_id_one'],'',$banlist);
mysqli_query($db,"UPDATE users SET banlist='$saveend' WHERE from_id='$from_id'");
$BOT->sendCommand('sendMessage',[
    'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
    'text'=>"🛡 تم رفع الحظر عن صاحب هذه الرسالة.",
]);
$BOT->sendCommand('sendMessage',[
'chat_id'=>$GetDB['from_id_one'],
'reply_to_message_id'=>$GetDB['message_id_one'],
    'text'=>"🛡 تم رفع الحظرك عنك.",
]);


}
}
if($reply and $messageText != "/ban" and $messageText != "/unban" and $messageText != "/stats" and $messageText != "/help"){
$msgid = $reply['message_id'];
$GetDB = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `messages` WHERE `from_id_two` ='$from_id' AND `message_id_two` ='$msgid'"));
if($GetDB){
$check = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `users` WHERE `from_id` ='".$GetDB['from_id_one']."'"));
$check = $check['step'];
$check = preg_match("/^(send)_(.*)/s",$check,$matcha);
$check = $matcha[2];
if($check == $from_id){
$BOT->sendCommand('sendMessage',[
'chat_id'=>$GetDB['from_id_one'],
'reply_to_message_id'=>$GetDB['message_id_one'],
'text'=>"✉️ رد على رسالتك:

$messageText
-",
]);
}else {
$BOT->sendCommand('sendMessage',[
    'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
    'text'=>"▫️عفواً لا يمكنك الرد على هذا الشخص

▪️لأنه قام بأغلاق إرسال الرسائل الخاصة بالصراحه ",
]);
}
}
}
if(preg_match("/^\/(start) (.*)/s",$messageText) and $messageText != "/start"){
preg_match("/^\/(start) (.*)/s",$messageText,$matcha);
$foreignkey = $matcha[2];
@$GetDB = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `users` WHERE `foreignkey` ='$foreignkey'"));
if ($from_id != $GetDB['from_id']){
$getex = explode(",",$GetDB['banlist']);
if(!in_array($from_id,$getex)){

$username = $GetDB['username'];
$username = base64_decode($username);
$is_username = $GetDB['is_username'];

$fromiddb = $GetDB['from_id'];
mysqli_query($db,"UPDATE users SET step='send_$fromiddb' WHERE from_id='$from_id'");

if($is_username == 1){
$username = "[@$username](t.me/$username)";
}else {
$username = "[$username](t.me/$Channel)";
}
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
   'text'=>"▪️ اهلاً بك ..
▫️ `سوف يتم إرسال الرسالة الى` ($username)` بسرية تامة .`
▫️`صارحني انا مستعد لمواجهة الصراحة .`
▫️`اكتب ماتريد في هذه المحدثة وسوف يتم إرسالها إلى` ($username)

💡 عند الانتهاء قم بالضغط على زر (🚫 الغاء إرسال الرسائل)

[🌐أضغط هنا وتابع جديدنا ](https://t.me/$Channel) 🌐

-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"🚫 الغاء إرسال الرسائل",'callback_data'=>"exit"],
                        ]
                ]
            ])
]);
}else {
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
    'text'=>"▪️ انت محضور من الدخول لصاحب هذا الرابط"
]);
}
}else {
$BOT->sendCommand('sendMessage',[
   'chat_id'=>$chatId,
    'reply_to_message_id'=>$messageId,
    'text'=>"▪️لا يمكنك الإرسال لنفسك .",
]);
}
}

if($updateData['inline_query']){
@$fetch = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `users` WHERE `from_id` ='$from_idinline'"));
$Link = $fetch['foreignkey'];
if($inlineqt == ''){
$BOT->sendCommand('answerInlineQuery', [
'inline_query_id' => $inlineid,
'is_personal' => true,
'results' => json_encode([[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🌐 شارك حسابك مع أصدقائك.',
'description' => 'اضغط هنا وسوف يتم ارسالها تلقائياً',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "▪️صارحني لتلقي النقد البناء بسرية تامة

▫️ [هنا يمكنك ارسال اي رسالة لي](http://t.me/$UserNameBot?start=$Link) , انا مستعد لمواجهة الصراحة 😅 .
-"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/$UserNameBot?start=".$Link]],
]]
]])
]);
}else{
    $BOT->sendCommand('answerInlineQuery', [
'inline_query_id' => $inlineid,
'is_personal' => true,
'results' => json_encode([[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🌐 شارك حسابك مع أصدقائك.',
'description' => 'اضغط هنا وسوف يتم ارسالها تلقائياً',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "▪️صارحني لتلقي النقد البناء بسرية تامة

▫️ [هنا يمكنك ارسال اي رسالة لي](http://t.me/$UserNameBot?start=$Link) , انا مستعد لمواجهة الصراحة 😅 .
-"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/$UserNameBot?start=".$Link]],
]]
],[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🔖 رسالة مخصصة .',
'description' => '📍سوف يتم إرسال ماتكتبه هنا.',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "$inlineqt"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/$UserNameBot?start=$Link"]],
]]
]])
]);
}
}