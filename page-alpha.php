<?php

use Timber\Timber;
$context = Timber::context();

$context['post'] = Timber::get_post();

Timber::render('pages/alpha.twig', $context);