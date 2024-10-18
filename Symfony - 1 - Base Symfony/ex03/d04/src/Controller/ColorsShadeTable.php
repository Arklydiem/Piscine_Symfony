<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColorsShadeTable extends AbstractController
{
    #[Route('/e03', name: 'colors_shades_table')]
    public function showColors(): Response
    {
        $numShades = $this->getParameter('e03.number_of_colors');

        $colors = [
            'black' => [0, 0, 0],
            'red'   => [255, 0, 0],
            'blue'  => [0, 0, 255],
            'green' => [0, 255, 0],
        ];

        $cellHeight = 40;
        $cellWidth = 80;

        $shades = [];
        foreach ($colors as $colorName => $rgb) {
            $shades[$colorName] = $this->generateShades($rgb, $numShades);
        }

        return $this->render('colors-shade-table.html.twig', [
            'shades' => $shades,
            'numShades' => $numShades,
            'cellHeight' => $cellHeight,
            'cellWidth' => $cellWidth,
        ]);
    }

    private function generateShades(array $rgb, int $numShades): array
    {
        $shades = [];
        $step = 255 / ($numShades - 1);

        for ($i = 0; $i < $numShades; $i++) {
            $shade = [
                min(255, $rgb[0] + $i * $step),
                min(255, $rgb[1] + $i * $step),
                min(255, $rgb[2] + $i * $step),
            ];
            $shades[] = sprintf('rgb(%d, %d, %d)', $shade[0], $shade[1], $shade[2]);
        }

        return $shades;
    }
}
