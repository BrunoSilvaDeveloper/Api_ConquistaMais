<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventoResource extends JsonResource
{
    public function toArray($request)
    {
        // Quebra do local_evento
        [$local, $resto] = explode(',', $this->local_evento);
        [$cidade, $estado] = explode('-', $resto);

        // Quebra da data_evento
        [$dataInicioRaw, $dataFimRaw] = explode('>', $this->data_evento);

        $meses = [
            'jan' => '01', 'fev' => '02', 'mar' => '03', 'abr' => '04',
            'mai' => '05', 'jun' => '06', 'jul' => '07', 'ago' => '08',
            'set' => '09', 'out' => '10', 'nov' => '11', 'dez' => '12',
        ];

        function formatarData($dataString, $meses)
        {
            preg_match('/(\d{2}) (\w{3}) - (\d{4})/', $dataString, $matches);
            if (count($matches) === 4) {
                [$_, $dia, $mesAbreviado, $ano] = $matches;
                $mes = $meses[strtolower($mesAbreviado)] ?? '01';
                return "{$dia}/{$mes}/{$ano}";
            }
            return null;
        }

        return [
            'id' => $this->id,
            'nome_evento' => $this->nome_evento,
            'tipo_evento' => $this->tipo_evento,
            'link_evento' => $this->link_evento,
            'link_imagem' => $this->link_imagem,
            'evento' => $this->evento,
            'local' => trim($local),
            'cidade' => trim($cidade),
            'estado' => trim($estado),
            'data_inicial' => formatarData($dataInicioRaw, $meses),
            'data_final' => formatarData($dataFimRaw, $meses),
        ];
    }
}
