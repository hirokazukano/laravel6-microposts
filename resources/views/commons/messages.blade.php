<?php
/**
 * Flashメッセージ表示
 */
?>
@if (session()->has('message'))
    <ul class="alert alert-info" role="alert">
        {{ session('message') }}
    </ul>
@endif
