<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfrRestTest\Factory;

use PHPUnit_Framework_TestCase;
use Zend\Http\Response as HttpResponse;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfrRest\Factory\HttpExceptionListenerFactory;
use ZfrRest\Factory\ModuleOptionsFactory;
use ZfrRest\Mvc\HttpExceptionListener;
use ZfrRest\Options\ModuleOptions;
use ZfrRestTest\Asset\HttpException\SimpleException;

/**
 * @license MIT
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 *
 * @group Coverage
 * @covers \ZfrRest\Factory\ModuleOptionsFactory
 */
class ModuleOptionsFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $options = [
            'zfr_rest' => [
                'exception_map' => [
                    'foo' => 'bar'
                ],
                'register_http_method_override_listener' => true
            ]
        ];

        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);

        $serviceLocator->expects($this->once())
                       ->method('get')
                       ->with('Config')
                       ->will($this->returnValue($options));

        $factory  = new ModuleOptionsFactory();
        $instance = $factory->createService($serviceLocator);

        $this->assertInstanceOf(ModuleOptions::class, $instance);
        $this->assertEquals($options['zfr_rest']['exception_map'], $instance->getExceptionMap());
        $this->assertTrue($instance->getRegisterHttpMethodOverrideListener());
    }
}
