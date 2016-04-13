<?php
require 'config.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: threads.php');
    die();
}
try {
    $thread = new Thread($_GET['id']);
} catch (Exception $e) {
    header('Location: threads.php?' . $e->getMessage());
}

$template = array(
    'title' => $thread->getTitle(),
    'activeLink' => 'threads',
    'header' => $thread->getTitle() . ' created by ' . $thread->getPoster()
);
require 'templates/header.php';
?>
    <div class="row">
        <div class="col-lg-3 col-md-3"></div>
        <div class="col-lg-6 col-md-6">
            <?php foreach($thread->getPosts() as $post) { ?>
                <b><?php echo $post->getPoster(); ?></b>
                <pre><?php echo $post->getContent(); ?></pre>
                <i><?php echo $post->getTimestamp(); ?></i>
                <br />
                <br />
            <?php } ?>
            <hr />
            <?php if(isset($user)) { ?>
    <form action="ajaxServer.php" method="post">
                <label for="post">Post:</label>
                <textarea class="form-control" name="post" id="post"></textarea>
                <br />
                <button type="submit" class="btn btn-info">Post</button>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <input type="hidden" name="command" value="post" />
            </form>
    <?php } ?>
        </div>
        <div class="col-lg-3 col-md-3"></div>
    </div>
<?php require 'templates/footer.php'; ?>