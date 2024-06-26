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
                The pagerank of the article get lost.
            </td>
        </tr>
        <tr>
            <td>redirect</td>
            <td>The article is still available, but it's canonical url is set to the relocate url, this should transfer the pagerank to the relocate url.</td>
        </tr>
</table>

## Developers

Following events are available:

| Name                    | Description                                                                                                 |
|-------------------------|-------------------------------------------------------------------------------------------------------------|
| GenerateArticleUrlEvent | Dispatched before the article url is searched in the sitemap url list to be removed. Allows modify the url. |


## Footnote

Relocated news are currently not removed from news lists as the hooks to do such things are very limited. 
You can filter them in your count and fetch items hook by adding `"tl_news.relocate = 'none'"` to the model columns array.