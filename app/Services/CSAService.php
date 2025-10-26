<?php

namespace App\Services;

class CSAService
{
    /**
     * Crow Search Algorithm (CSA) - OOP + Convergence Log
     * PHP 8.0+; tanpa pustaka eksternal.
     *
     * @throws \InvalidArgumentException
     */
    private int $numCrows;

    private int $numIterations;

    private float $alpha;

    private float $beta;

    /** Riwayat (iteration => bestScore) bila diminta */
    private array $history = [];

    public function __construct(int $numCrows = 10, int $numIterations = 100, float $alpha = 0.5, float $beta = 1.5)
    {
        if ($numCrows < 1 || $numIterations < 1) {
            throw new \InvalidArgumentException('numCrows minimal 1 or numIterations minimal 1.');
        }
        $this->numCrows = $numCrows;
        $this->numIterations = $numIterations;
        $this->alpha = $alpha;
        $this->beta = $beta;
    }

    public function getHistory(): array
    {
        return $this->history; // [iter => bestScore]
    }

    /**
     * Jalankan CSA.
     *
     * @throws \InvalidArgumentException
     * @param  array<int|float>  $values  Dataset diskret yang akan dicari index minimum/maksimumnya
     * @param  'min'|'max'  $mode  Mode optimisasi (CSA meminimasi; untuk 'max' kita negasikan nilai)
     * @param  bool  $recordHistory  Simpan log konvergensi
     * @return array{bestIndex:int, bestValue:float}
     */
    public function run(array $values, string $mode = 'min', bool $recordHistory = false): array
    {
        if ($values === []) {
            throw new \InvalidArgumentException('values tidak boleh kosong.');
        }
        if ($mode !== 'min' && $mode !== 'max') {
            throw new \InvalidArgumentException("mode harus 'min' atau 'max'.");
        }

        // Siapkan fungsi objektif; CSA meminimasi.
        $objective = $mode === 'min'
            ? fn(int $i): float => (float) $values[$i]
            : fn(int $i): float => -(float) $values[$i];

        $numPositions = count($values);
        $crows = $this->initializePopulation($this->numCrows, $numPositions);

        // Global best awal
        [$globalBest, $bestScore] = $this->bestOf($crows, $objective);

        if ($recordHistory) {
            $this->history = [0 => $bestScore];
        }

        for ($iter = 1; $iter <= $this->numIterations; $iter++) {
            for ($i = 0; $i < $this->numCrows; $i++) {
                $newPos = $this->updateCrow($crows[$i], $globalBest, $numPositions);

                $oldScore = $objective($crows[$i]);
                $newScore = $objective($newPos);

                if ($newScore < $oldScore) {
                    $crows[$i] = $newPos;
                    if ($newScore < $bestScore) {
                        $bestScore = $newScore;
                        $globalBest = $newPos;
                    }
                }
            }
            if ($recordHistory) {
                $this->history[$iter] = $bestScore;
            }
        }

        // Nilai asli (bukan yang dinegasikan)
        $bestValue = (float) $values[$globalBest];

        return ['bestIndex' => $globalBest, 'bestValue' => $bestValue];
    }

    /* ------------------- Utilitas internal ------------------- */

    private function initializePopulation(int $n, int $numPositions): array
    {
        $pop = [];
        for ($i = 0; $i < $n; $i++) {
            $pop[] = mt_rand(0, $numPositions - 1);
        }

        return $pop;
    }

    /** @param callable $objective fn(int $i): float */
    private function bestOf(array $positions, callable $objective): array
    {
        $bestIdx = $positions[0];
        $bestVal = $objective($bestIdx);
        foreach ($positions as $p) {
            $v = $objective($p);
            if ($v < $bestVal) {
                $bestVal = $v;
                $bestIdx = $p;
            }
        }

        return [$bestIdx, $bestVal];
    }

    private function updateCrow(int $pos, int $gBest, int $numPositions): int
    {
        $rand = $this->randomFloat(-1.0, 1.0);
        $new = $pos + ($this->alpha * ($gBest - $pos)) + ($this->beta * $rand);

        $new = (int) round($new);
        if ($new < 0) {
            $new = 0;
        }
        if ($new >= $numPositions) {
            $new = $numPositions - 1;
        }

        return $new;
    }

    private function randomFloat(float $min, float $max): float
    {
        return $min + ((mt_rand() / mt_getrandmax()) * ($max - $min));
    }
}

/* =================== Contoh penggunaan (CLI) ===================
 * if (php_sapi_name() === 'cli') {
 * $values = [3, 1, 5, 7, 2, 8, 6, 4];
 *
 * $csa = new CrowSearch(
 * numCrows: 10,
 * numIterations: 100,
 * alpha: 0.5,
 * beta: 1.5,
 * );
 *
 * // Cari minimum
 * $minRes = $csa->run($values, mode: 'min', recordHistory: true);
 * echo "MIN -> index: {$minRes['bestIndex']}, value: {$minRes['bestValue']}\n";
 *
 * // Ambil log konvergensi (opsional)
 * $histMin = $csa->getHistory();
 * echo "Min convergence (iter=>bestScore):\n";
 * foreach ($histMin as $iter => $score) {
 * echo "  {$iter}: {$score}\n";
 * }
 *
 * // Cari maksimum
 * $maxRes = $csa->run($values, mode: 'max', recordHistory: true);
 * echo "MAX -> index: {$maxRes['bestIndex']}, value: {$maxRes['bestValue']}\n";
 * }
 */
