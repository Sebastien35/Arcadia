<?php

namespace App\Security;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppCustomAuthAuthenticator extends AbstractLoginFormAuthenticator implements LoggerAwareInterface
{
    public function supports(Request $request): bool
{
    $supports = $request->attributes->get('_route') === self::LOGIN_ROUTE 
       && $request->isMethod('POST');

    $this->logger->info('Supports: ' . ($supports ? 'true' : 'false'));

    return $supports;
    
}
    use TargetPathTrait;
    use LoggerAwareTrait;
    public const LOGIN_ROUTE = 'app_login';
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getCredentials(Request $request): array
    {   
        $email = $request->request->get('email', '');
        $password = $request->request->get('password','');

        $email = htmlspecialchars(trim($email));
        $password = htmlspecialchars(trim($password));
        return [
            'email' => $email,
            'password' => $password,
        ];
    }

    public function authenticate(Request $request): Passport
    {   
        $credentials = $this->getCredentials($request);
        $email = $credentials['email'];
        $password = $credentials['password'];
        $this->logger->info('Login attempt with email: ' . $email );
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
         if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
         }

        return new RedirectResponse($this->urlGenerator->generate('app_acceuil'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));
    
    }


    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}