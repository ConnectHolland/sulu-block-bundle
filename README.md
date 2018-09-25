# Sulu block bundle
A Symfony Bundle for Sulu content management platform containing boilerplate blocks

## 1. Installation
### Composer
```bash
composer require connectholland/sulu-block-bundle
```
### Activation of the bundle
Add the bundle class to `app/AbstractKernel.php` in the `registerBundles` function
```php
new ConnectHolland\Sulu\BlockBundle\ConnectHollandSuluBlockBundle()
```

## 2. Usage
### Template
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
### Twig
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
#### Override twig templates
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

## 4. Adding additional properties
When using a block and you want to add additional properties, you can configure them separately in `app/Resources/ConnectHollandSuluBlockBundle/templates/properties/{blockname}.xml`.
For instance, if you want to add a caption to the images block. You would create the following file in your client app:
```xml
<!-- app/Resources/ConnectHollandSuluBlockBundle/templates/properties/images.xml -->
<?xml version='1.0' ?>
<properties xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <property name='caption' type='text_line'>
        <meta>
            <title lang='en'>Caption</title>
            <title lang='nl'>Bijschrift</title>
        </meta>
    </property>
</properties>
```

## 5. Override params of a property

### 5.1 Fully override all params
When using a block and you want to choose all the params of the blocks properties yourself, you can configure them separately in `app/Resources/ConnectHollandSuluBlockBundle/templates/params/{blockname}.xml`.
For instance, if you want to set all the params for the text editor property. You would create the following file in your client app:
```xml
<!-- app/Resources/ConnectHollandSuluBlockBundle/templates/params/text_editor.xml -->
<?xml version='1.0' ?>
<params xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <param name="link" value="true"/>
    <param name="paste_from_word" value="true"/>
    <param name="height" value="100"/>
    <param name="max_height" value="200"/>
</params>
```

### 5.2 Adjust params
When using a block and you want to change the params of the blocks properties, you can configure them separately in `app/Resources/ConnectHollandSuluBlockBundle/templates/params/{blockname}_adjustments.xml`.
For instance, if you want to adjust the height and disable table functionality of the text_editor property. You would create the following file in your client app:
```xml
<!-- app/Resources/ConnectHollandSuluBlockBundle/templates/params/text_editor_adjustments.xml -->
<?xml version='1.0' ?>
<params xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <params name='height' type='200'/>
    <params name='table' type='false'/>
</params>
```

### 5.3 Add params
When using a block and you want to add params to the blocks properties, you can configure them separately in `app/Resources/ConnectHollandSuluBlockBundle/templates/params/{blockname}_additions.xml`.
For instance, if you want to add ui_color param to the text_editor property. You would create the following file in your client app:
```xml
<!-- app/Resources/ConnectHollandSuluBlockBundle/templates/params/text_editor_additions.xml -->
<?xml version='1.0' ?>
<params xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <param name="ui_color" value="#ffcc00"/>
</params>
```
