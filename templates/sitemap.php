<?php
status_header(200);
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach (\App\Sitemp::sitemapData() as $urlData): ?>
    <url>
        <loc><?= $urlData['url'] ?></loc>
    </url>
<?php
endforeach;

echo '</urlset>';