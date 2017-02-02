# Sulu block bundle
A Symfony Bundle for Sulu content management platform containing boilerplate blocks

## 1. Installation
###Composer
```bash
composer require connectholland/sulu-block-bundle
```
###Activation of the bundle
Add the bundle class to `app/AbstractKernel.php` in the `registerBundles` function
```php
new ConnectHolland\Sulu\BlockBundle\ConnectHollandSuluBlockBundle()
```

## 2. Usage
###Template
Add or adjust a page template file (be aware of adding xmlns:xi="http://www.w3.org/2001/XInclude")
```xml
<!-- app/Resources/templates/pages/default.xml -->
<?xml version="1.0" ?>
<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xmlns:xi="http://www.w3.org/2001/XInclude"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd">

    <key>default</key>

    <view>templates/default</view>
    <controller>SuluWebsiteBundle:Default:index</controller>
    <cacheLifetime>2400</cacheLifetime>

    <meta>
        <title lang="en">Default</title>
        <title lang="nl">Standaard</title>
    </meta>

    <properties>
        <!--
        <section name="highlight">
            <properties>
                <property name="title" type="text_line" mandatory="true">
                    <meta>
                        <title lang="en">Title</title>
                        <title lang="nl">Titel</title>
                    </meta>
                    <params>
                        <param name="headline" value="true"/>
                    </params>

                    <tag name="sulu.rlp.part"/>
                </property>

                <property name="url" type="resource_locator" mandatory="true">
                    <meta>
                        <title lang="en">Resourcelocator</title>
                        <title lang="nl">Adres</title>
                    </meta>

                    <tag name="sulu.rlp"/>
                </property>
            </properties>
        </section>

        <property name="article" type="text_editor">
            <meta>
                <title lang="en">Article</title>
                <title lang="de">Artikel</title>
            </meta>
        </property>-->

        <!-- Choose the same name as using in twig (see next paragraph) -->
        <block name="blocks" default-type="text" minOccurs="0">
            <meta>
                <title lang="en">Content</title>
                <title lang="nl">Inhoud</title>
            </meta>
            <types>
                <xi:include href="sulu-block-bundle://blocks/text.xml"/>
                <xi:include href="sulu-block-bundle://blocks/youtube.xml"/>
            </types>
        </block>

        <!-- Choose the same name as using in twig (see next paragraph) -->
        <block name="banners" default-type="text" minOccurs="0">
            <meta>
                <title lang="en">Banners</title>
                <title lang="nl">Banners</title>
            </meta>
            <types>
                <xi:include href="sulu-block-bundle://blocks/text.xml"/>
                <xi:include href="sulu-block-bundle://blocks/youtube.xml"/>
            </types>
        </block>
    </properties>
</template>
```
###Twig
Add includes to your twig templates
```twig
{% block content %}
    <div vocab='http://schema.org/' typeof='Content'>
        <h1 property='title'>{{ content.title }}</h1>

        <div property='article'>
            {{ content.article|raw }}
        </div>

        {% include 'ConnectHollandSuluBlockBundle::html5-blocks.html.twig' %}
        {% include 'ConnectHollandSuluBlockBundle::html5-blocks.html.twig' with {element: 'aside', collection: 'banners'} %}
    </div>
{% endblock %}
```
####Override twig templates
Put twig templates with the same name as the ones you want to override in `app/Resources/ConnectHollandSuluBlockBundle`.
So if you want to override `src/Resources/views/html5/parts/images.html.twig` of this bundle, you should create the file `app/Resources/ConnectHollandSuluBlockBundle/views/html5/parts/images.html.twig`.

And if you only want to override certain blocks of the templates in this bundle, you can extend the base template by using the namespace `@sulu-block-bundle`.

For example like this:
```twig
{# app/Resources/ConnectHollandSuluBlockBundle/views/html5/parts/images.html.twig #}
{% extends "@sulu-block-bundle/html5/parts/images.html.twig" %}

{% block image_source %}{{ image.thumbnails['50x50'] }}{% endblock %}
```

## 3. Available blocks
- Text with title (text)
- Images with title (images)
- Images with title and text (images_text)
- Youtube video with title (youtube)
- Link with title (link)
