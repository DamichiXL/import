<?php

it('Stores imported data', function () {
    $this->post(route('store'), [

    ])->assertOk();
});
