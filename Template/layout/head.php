<?
$endereco = $this->url->href(
    'Notify',
    'show',
    array('plugin' => 'Notify')
);

echo "<link rel='notification-watch' href='".$endereco."' />";
?>