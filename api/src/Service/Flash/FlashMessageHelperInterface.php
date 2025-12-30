<?php

namespace App\Service\Flash;

use Symfony\Component\Form\FormInterface;

/**
 * Service for handling flash messages.
 */
interface FlashMessageHelperInterface
{
    public function addFlash(string $type, string $message) : void;
    public function addFormErrorsAsFlash(FormInterface $form) : void;
}