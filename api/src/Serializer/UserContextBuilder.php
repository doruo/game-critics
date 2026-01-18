<?php
// api/src/Serializer/BookContextBuilder.php
namespace App\Serializer;

use App\Entity\User;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\State\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class UserContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker,private EntityManagerInterface $entityManager)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;
        $id = $request->attributes->get('id') ?? null;

        // if a road add a ' "skipCustomContextBuilder" => true ' in their normalizationContext we don't touch the context
        if (($extractedAttributes['operation']->getNormalizationContext()['skipCustomContextBuilder'] ?? false) === true) {
            return $context;
        }


        if ($resourceClass === User::class && isset($context['groups']) && true === $normalization) {
            // on normalize donc on doit pouvoir trouver un ressource si la requete est valide
            $user = null;

            if ($id !== null) {
                $user = $this->entityManager
                    ->getRepository(User::class)
                    ->find($id);
            }
            if($this->authorizationChecker->isGranted('USER_SELF_CONNECTED_OR_ADMIN',$user)){
                $context['groups'][] = 'serialization:user:read:private';
            }
        }

        return $context;
    }
}