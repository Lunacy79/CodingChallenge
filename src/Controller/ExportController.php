<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ExportController extends AbstractController
{
    public function getUserData()
    {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
            
        $user = $repository->findAll();

        if (!$user) {
            throw $this->createNotFoundException(
                'No users found.'
            );
        }
        
        return $user;
    }
}