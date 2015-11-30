<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AppBundle\Manager\Front;

use WellCommerce\Bundle\AppBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\AppBundle\Entity\ProductInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\FrontManagerInterface;
use WellCommerce\Bundle\AppBundle\Entity\CartInterface;
use WellCommerce\Bundle\AppBundle\Entity\CartProductInterface;

/**
 * Interface CartProductManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductManagerInterface extends FrontManagerInterface
{
    /**
     * Initializes product object
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     * @param int                            $quantity
     *
     * @return \WellCommerce\Bundle\AppBundle\Entity\CartProductInterface
     */
    public function initCartProduct(
        CartInterface $cart,
        ProductInterface $product,
        ProductAttributeInterface $attribute = null,
        $quantity = 1
    );


    /**
     * Removes a product from cart
     *
     * @param CartProductInterface $cartProduct
     * @param CartInterface        $cart
     */
    public function deleteCartProductFromCart(CartProductInterface $cartProduct, CartInterface $cart);

    /**
     * Returns the CartProduct object from cart or null if it was not found
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     *
     * @return null|\WellCommerce\Bundle\AppBundle\Entity\CartProductInterface
     */
    public function findProductInCart(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null);

    /**
     * Adds a new product to cart or increments its quantity
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     * @param int                            $quantity
     */
    public function addProductToCart(
        CartInterface $cart,
        ProductInterface $product,
        ProductAttributeInterface $attribute = null,
        $quantity = 1
    );

    /**
     * Changes products quantity or deletes it from cart if 0 quantity was given
     *
     * @param CartProductInterface $cartProduct
     * @param int                  $qty
     */
    public function changeCartProductQuantity(CartInterface $cart, CartProductInterface $cartProduct, $qty);
}
