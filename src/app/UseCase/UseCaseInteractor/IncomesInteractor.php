<?php

namespace App\Application\UseCase;

use App\Application\UseCase\Input\IncomesInput;
use App\Application\UseCase\Output\IncomesOutput;
use App\Domain\Entity\Income;
use App\Domain\Repository\IncomeRepository;

class IncomesInteractor
{
    private $incomeRepository;
    private $input;

    public function __construct(IncomesInput $input, IncomeRepository $incomeRepository)
    {
        $this->input = $input;
        $this->incomeRepository = $incomeRepository;
    }

    public function handle(): IncomesOutput
    {
        $income = new Income(
            $input->getUserId()->getValue(),
            $input->getIncomeSourceId()->getValue(),
            $input->getAmount()->getValue(),
            $input->getAccrualDate()->getValue()
        );

        $this->incomeRepository->save($income);

        return new IncomesOutput($income);
    }
}