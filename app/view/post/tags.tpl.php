<h2>Taggar</h2>
<div class='tags nounderline'>
<?php
$taggar = array();

foreach($posts as $post) {
    $info = $post->getProperties();
    $tags = explode(',', $info['tags']);
    foreach($tags as $tag) {
        $taggar[] = $tag;
    }
}
$taggar = array_count_values($taggar);

foreach($taggar as $tag => $val) {
    $url = $this->url->create('posts/viewOneTag/' . $tag);

    echo <<<EOD
        <a href="$url">($val)$tag</a>
EOD;

}
?>


</div>
