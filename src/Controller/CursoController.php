<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path = "/api")
 */
class CursoController extends AbstractController
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * REST action que obtiene la informacion de un curso a partir de su id
     * pasado por parámetro
     *
     * output json keys = 'id', 'titulo', 'descripcion', 'precio', 'opiniones', 'top'
     *
     * statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when not found"
     * }
     *
     * @Route("/cursos/{id}", name="api_curso", methods={"GET"})
     *
     * @param int $id Id del curso a buscar
     *
     * @return JsonResponse
     */
    public function getCurso(int $id): JsonResponse
    {
        $curso = $this->getCursoJson($id);
        if (!$curso) {
            return new JsonResponse(['mensaje' => 'Curso no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $opiniones = $this->getOpinionesJson($curso['id']);

        $curso['opiniones'] = $opiniones;
        $curso['top'] = $this->isTop($curso);

        return new JsonResponse($curso, Response::HTTP_OK);
    }

    /**
     * Devuelve la información de un curso a partir de su id pasado por parámetro
     * En caso de no encontrarlo, devolverá null
     *
     * @param  int    $id Id del curso a buscar
     * @return ?array
     */
    private function getCursoJson(int $id): ?array
    {
        $cursosJson = file_get_contents("{$this->projectDir}/data/cursos.json");
        $cursos = json_decode($cursosJson, true);

        $cursosFilter = array_filter($cursos, function ($c) use ($id) {
            return $c['id'] == $id;
        });

        return array_shift($cursosFilter);
    }

    /**
     * Devuelve las opiniones de un curso a partir de su id
     *
     * @param  int    $id Id del curso a buscar
     * @return array
     */
    private function getOpinionesJson(int $idCurso): array
    {
        $opinionesJson = file_get_contents("{$this->projectDir}/data/opiniones.json");
        $opiniones = json_decode($opinionesJson, true);

        return array_filter($opiniones, function ($o) use ($idCurso) {
            return $o['curso_id'] == $idCurso;
        });
    }

    /**
     * Indica si es un curso TOP ó no a partir de la media de las
     * valoraciones de sus opiniones
     *
     * @param  array    $curso  Curso a buscar
     * @return bool
     */
    private function isTop(array $curso): bool
    {
        if ($curso['opiniones'] == 0) {
            return false;
        }

        $avg = array_sum(array_map(
            function ($o) {
                return $o['valoracion'];
            },
            $curso['opiniones']
        )) / count($curso['opiniones']);

        return ($avg == 5) ? true : false;
    }
}
