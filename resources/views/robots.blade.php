User-agent: *
Disallow: /admin
Disallow: /login
Disallow: /logout
Disallow: /api
Disallow: /test
Disallow: /debug
Disallow: /temp
Disallow: /contact/verify/
Disallow: /*.json$
Allow: /

Sitemap: {{ url('/sitemap.xml') }}
