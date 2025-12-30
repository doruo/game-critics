<?php

namespace App\Service\Flash;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Service for handling flash messages.
 */
final readonly class FlashMessageHelper implements FlashMessageHelperInterface
{
    public function __construct(private RequestStack $requestStack){}

    public function addFlash(string $type, string $message) : void
    {
        $flashBag = $this->getFlashBag();
        $flashBag->add($type, $message);
    }

    public function addFormErrorsAsFlash(FormInterface $form) : void
    {
        $errors = $form->getErrors(true);
        $flashBag = $this->getFlashBag();
        foreach ($errors as $error) {
            $flashBag->add("error", $error->getMessage());
        }
    }

    public function getFlashBag() : FlashBagInterface {
        return $this->requestStack->getSession()->getFlashBag();
    }
}