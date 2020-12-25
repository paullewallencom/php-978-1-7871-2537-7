<?
include_once 'libraries.php';

$url = "http://localhost/private_messages/public/messages/user/".$arrUser['id'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);
$messages = json_decode($result, true);


if ( !empty($_POST['submit']) ) {

    if ( !empty($_POST['sender']) ) 		$sender 		= $_POST['sender'];
    if ( !empty($_POST['recipient']) ) 		$recipient 		= $_POST['recipient'];
    if ( !empty($_POST['message']) ) 		$message 		= $_POST['message'];

    if ( empty($sender) ) 	$error['sender'] 		= 'Sender not found';
    if ( empty($recipient) ) 	$error['recipient'] 		= 'Please select a recipient';
    if ( empty($message) ) 	$error['message'] 		= 'Please complete the message';

    if ( empty($error) ) {
        $url = "http://localhost/private_messages/public/messages/sender/".$sender."/recipient/".$recipient;

        $handler = curl_init();
        curl_setopt($handler, CURLOPT_URL, $url);
        curl_setopt($handler, CURLOPT_POST,true);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, "message=".$message);
        $response = curl_exec ($handler);

        curl_close($handler);

        header( 'Location: messages.php?sent=true' );
        die;

    }

}

$arrUsers = array();
$query = "SELECT id, username FROM `users` ORDER BY username ASC";
$result = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($result)) {
    array_push( $arrUsers,$row );
}

include_once 'header.php';
?>
    <p class="bg-success">
        <?php if ($_GET['sent']) { ?>
            The message was sent!
        <?php } ?>
    </p>
    <h1>Messages</h1>
    <?php foreach($messages as $message) { ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Message from <?php echo $arrUsers[$message['sender_id']]['username'];?></h3>
        </div>
        <div class="panel-body">
            <?php echo $message['message']; ?>
        </div>
    </div>
    <?php } ?>
    <h1>Send message</h1>
    <div>
        <form action="messages.php" method="post">
            <div class="form-group">
                <label for="category_id">Recipient</label>
                <select class="form-control" name="recipient">
                    <option value="">Select User</option>
                    <option value="">------------------------</option>
                    <?php foreach($arrUsers as $user) { ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Message</label><br />
                <input name="message" type="text" value="" class="form-control" />
            </div>
            <input name="sender" type="hidden" value="<?php echo $arrUser['id']; ?>" />

            <div class="form-group">
                <input name="submit" type="submit" value="Send message" class="btn btn-primary" />
            </div>

        </form>
    </div>
<?php include_once 'footer.php'; ?>