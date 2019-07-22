<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AssembleVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'DELETE'])
            && $subject instanceof \App\Entity\Assemble;
    }

    protected function voteOnAttribute($attribute, $assemble, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (null == $assemble->getUser()) {
            return false;
        }
        switch ($attribute) {
            case 'EDIT':
                return $assemble->getUser()->getId() == $user->getId();
                break;
            case 'DELETE':
                return $assemble->getUser()->getId() == $user->getId();
                break;
        }

        return false;
    }
}
