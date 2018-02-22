<?php

/*
 * This file is part of the Superdesk Web Publisher Content Bundle.
 *
 * Copyright 2016 Sourcefabric z.ú. and contributors.
 *
 * For the full copyright and license information, please see the
 * AUTHORS and LICENSE files distributed with this source code.
 *
 * @copyright 2016 Sourcefabric z.ú
 * @license http://www.superdesk.org/license
 */

namespace SWP\Bundle\ContentBundle\Tests;

use SWP\Bundle\ContentBundle\Loader\RouteLoader;
use SWP\Bundle\ContentBundle\Tests\Functional\WebTestCase;

class RouteLoaderTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();
    }

    public function testFindRoute()
    {
        $routeLoader = new RouteLoader(
            $this->getContainer()->get('swp_template_engine_context.factory.meta_factory'),
            $this->getContainer()->get('swp.repository.route')
        );

        $meta = $routeLoader->load('route', ['route_object' => $this->getContainer()->get('swp.factory.route')->create()]);
        $this->assertNotNull($meta);

        $meta = $routeLoader->load('route', []);
        $this->assertFalse($meta);
    }
}
