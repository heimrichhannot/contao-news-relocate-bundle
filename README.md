# Contao News Relocate Bundle

This contao extension allows to relocate news articles, e.g. set a replacement article and force a redirect or pagerank transmission.


## Install

Install with contao manager or with composer: 

```bash
composer require heimrichhannot/contao-news-relocate-bundle
```

Update the database.

## Usage

Go to the news article you want to relocate, select the relocate type and provide the relocate url.

<table>
    <thead>
        <tr>
            <th>Relocate Type</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>deindex</td>
            <td>
                The article will not be available anymore and calling the url will redirect to the provided relocate url.<br>
                The article will not be indexed by the search indexer and will be removed from the sitemap.
            </td>
        </tr>
        <tr>
            <td>redirect</td>
            <td>The article is still available, but it's canonical url is set to the relocate url.</td>
        </tr>
</table>