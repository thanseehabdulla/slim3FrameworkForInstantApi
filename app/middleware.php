<?php

// Application middleware

$app->add(function ($request, $response, $next) {

    $responsen = $response->withHeader('Content-Type', 'application/json')
                          ->withHeader('X-Powered-By', $this->settings['PoweredBy']);
	
	
	$APIRateLimit = new App\Utils\APIRateLimiter($this);
	$mustbethrottled = $APIRateLimit();
	
	if ($mustbethrottled == false) {
    $responsen = $next($request, $responsen);
	} else {
        $responsen = $responsen ->withStatus(429)
                                ->withHeader('RateLimit-Limit', $this->settings['api_rate_limiter']['requests']);
	}

    return $responsen;
});
