<?php
/**
 * Copyright © 2018, Ambroise Maupate
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @file LimitColorsProcessor.php
 * @author Ambroise Maupate
 */
namespace AM\InterventionRequest\Processor;

use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LimitColorsProcessor
 *
 * @package AM\InterventionRequest\Processor
 */
class LimitColorsProcessor implements Processor
{
    /**
     * @param Image $image
     * @param Request $request
     * @return void
     */
    public function process(Image $image, Request $request)
    {
        if ($request->query->has('background') ||
            $request->query->has('limit_color')) {
            $background = $request->query->has('background') ?
                                        $request->query->get('background') :
                                        $request->query->get('limit_color');

            if (1 === preg_match('#^([0-9a-f]{6})$#', $background ?? '')) {
                // count higher than 256 does not trigger palette creation
                $image->limitColors(257, '#' . $background);
            }
        }
    }
}
