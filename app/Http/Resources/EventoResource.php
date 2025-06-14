<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventoResource extends JsonResource
{
    public function toArray($request)
    {
        $eventoLimpo = str_replace("\u{A0}", ' ', $this->local_evento);
        $eventoLimpo = preg_replace('/\x{00A0}/u', ' ', $eventoLimpo); // compatibilidade extra

        [$local, $resto] = explode(',', $eventoLimpo) + [null, null];
        [$cidade, $estado] = explode('-', $resto) + [null, null];

        $meses = [
            'jan' => '01', 'fev' => '02', 'mar' => '03', 'abr' => '04',
            'mai' => '05', 'jun' => '06', 'jul' => '07', 'ago' => '08',
            'set' => '09', 'out' => '10', 'nov' => '11', 'dez' => '12',
        ];

        return [
            'id' => $this->id,
            'nome_evento' => $this->nome_evento,
            'tipo_evento' => $this->tipo_evento,
            'link_evento' => $this->link_evento,
            'link_imagem' => $this->link_imagem,
            'evento' => $this->evento,
            'local' => trim($local ?? ''),
            'cidade' => trim($cidade ?? ''),
            'estado' => trim($estado ?? ''),
            'data_inicial' => $this->formatarData($this->data_evento, $meses, true),
            'data_final' => $this->formatarData($this->data_evento, $meses, false),
        ];
    }

    private function formatarData($dataCompleta, $meses, $inicio = true)
    {
        $partes = explode('>', $dataCompleta);
        $alvo = $inicio ? ($partes[0] ?? '') : ($partes[1] ?? '');

        preg_match('/(\d{2}) (\w{3}) - (\d{4})/', $alvo, $matches);
        if (count($matches) === 4) {
            [$_, $dia, $mesAbreviado, $ano] = $matches;
            $mes = $meses[strtolower($mesAbreviado)] ?? '01';
            return "{$dia}/{$mes}/{$ano}";
        }
        return null;
    }

}
