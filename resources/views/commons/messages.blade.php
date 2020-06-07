@if (session()->has('message'))
    <ul class="alert alert-info" role="alert">
        {{ session('message') }}
    </ul>
@endif


<?php

if (isset($this->_name)) {
    // なにかする
}

if (isset($array['hoge'])) {
    // なにかする
}
