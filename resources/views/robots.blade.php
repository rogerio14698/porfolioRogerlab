User-agent: *
Disallow: /admin
Disallow: /api
Disallow: /test
Disallow: /debug
Disallow: /temp
Disallow: /*.json$
Allow: /

Sitemap: {{ url('/sitemap.xml') }}
