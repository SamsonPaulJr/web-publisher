Fixtures Bundle
===============

Overview
--------

The Fixtures Bundle helps developers to create fixtures or fake data 
that can be used for development and/or testing purposes.

It relies on the following 3rd party libraries:

`DoctrineFixturesBundle`_ (gives possibility to load data fixtures
programmatically into the Doctrine ORM or ODM)

`fzaninotto/Faker`_ (generates fake data for you)

`nelmio/alice`_ (gives you a few essential tools to make it very easy to 
generate complex data with constraints in a readable and easy to edit way)

It also provides the possibility to set up a ready-to-use demo theme, for 
development.

How to use fixtures
-------------------

The following chapter describes how to make use of the Fixtures Bundle 
features.

Creating a simple PHP fixture class
-----------------------------------

Fixtures should be created inside
``SWP\FixturesBundle\DataFixtures\<db_driver>`` directory and by convention, 
should be called like: ``LoadPagesData``, ``LoadArticlesData``, 
``LoadUsersData`` etc.

Replace ``db_driver`` either with ``ORM`` for the Doctrine ORM or
``PHPCR`` for the Doctrine PHPCR ODM.

Example Fixture class:

.. code-block:: php

    <?php
    namespace SWP\FixturesBundle\DataFixtures\ORM;

    use Doctrine\Common\DataFixtures\FixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use SWP\Bundle\FixturesBundle\AbstractFixture;

    class LoadPagesData extends AbstractFixture implements FixtureInterface
    {
        /**
         * {@inheritdoc}
         */
        public function load(ObjectManager $manager)
        {
            $env = $this->getEnvironment();
            $this->loadFixtures(
                '@SWPFixturesBundle/Resources/fixtures/ORM/'.$env.'/page.yml',
                $manager
            );
        }
    }

Each fixture class extends AbstractFixture class and implements
FixtureInterface. This way we can use the ``load`` method, inside which we
can create some objects using PHP and/or make use of `nelmio/alice`_ and
`fzaninotto/Faker`_ by loading fixtures in YAML format, as shown in the
example above.

Creating a simple Alice fixture (YAML format)
---------------------------------------------

For more details on how to create Alice fixtures, please see the
`Alice documentation`_ as a reference.

Example Alice fixture:

.. code-block:: yaml

    SWP\CoreBundle\Entity\Page:
        page1:
            name: "About Us"
            type: 1
            slug: "about-us"
            templateName: "static.html.twig"
            contentPath: "/swp/content/about-us"
        page2:
            name: "Features"
            type: 1
            slug: "features"
            templateName: "features.html.twig"
            contentPath: "/swp/content/features"
        page3:
            name: "Get Involved" # we can also use faker library formatters like: <paragraph(20)> etc
            type: 1
            slug: "get-involved"
            templateName: "involved.html.twig"
            contentPath: "/swp/content/get-involved"

The above configuration states that we want to persist into the database three 
objects of type ``SWP\CoreBundle\Entity\Page``. We can use the faker
`formatters`_ where, for example, ``<paragraph(20)>`` is one of the
`fzaninotto/Faker`_ formatters, which tells Alice to generate 20
paragraphs filled with fake data.

By convention, Alice YAML files should be placed inside 
``Resources/fixtures/<db_driver>/<environment>``, where <environment> is the 
current environment name (dev, test).

For instance, having the ``Resources/fixtures/ORM/test/page.yml`` Alice
fixture, we will be able to persist fake data defined in the YAML file into
the database (using Doctrine ORM driver), only when the ``test`` environment
is set or defined differently in
``SWP\FixturesBundle\DataFixtures\ORM\LoadPagesData.php``.

There is a lot of flexibility on how to define fixtures, so it’s up to the
developer how to create them.

Loading all fixtures
--------------------

**Note:** Remember to update your database schema before loading
fixtures! To do this, run in a console:

.. code-block:: bash

    php app/console doctrine:schema:update --force

Once you have your fixtures defined, we can simply load them. To do that
you must execute console commands.

To load Doctrine ORM fixtures:

.. code-block:: bash

    php app/console doctrine:fixtures:load --append

See ``php app/console doctrine:fixtures:load --help`` for more details.

After executing the commands above, your database will be filled with the
fake data, which can be used by themes.

.. _setting-up-demo-theme:

Setting up a demo theme
-----------------------

To make it easier to start with the Web Publisher, we created a simple
demo theme. To set this theme as an active one, you need to execute the
following command in a console:

.. code-block:: bash

    php app/console swp:theme:install 123abc src/SWP/Bundle/FixturesBundle/Resources/themes/DefaultTheme/ -f -p

This command will install default theme for the default tenant which was already created by loading fixtures (see above).

See ``php app/console swp:theme:install --help`` for more details.

.. _formatters: https://github.com/fzaninotto/Faker#formatters
.. _DoctrineFixturesBundle: https://github.com/doctrine/DoctrineFixturesBundle
.. _fzaninotto/Faker: https://github.com/fzaninotto/Faker
.. _nelmio/alice: https://github.com/nelmio/alice
.. _Alice documentation: https://github.com/nelmio/alice/blob/master/doc/complete-reference.md#complete-reference
