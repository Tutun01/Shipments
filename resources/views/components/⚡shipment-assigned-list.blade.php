<?php

use Livewire\Component;

new class extends Component
{
  public int $count = 0;
  public int $amount = 1;
  public string $errorMessage = "";

    public function increase()
    {
        $this->count += $this->amount;
    }

    public function reduce()
    {
        if ($this->count - $this->amount < 0) {
            $this->errorMessage = 'X';
            return;
        }

        $this->errorMessage = '';
        $this->count -= $this->amount;
    }

    public function validateAmount()
    {
        if($this->amount < 1) {
            $this->errorMessage = "The amount cannot be less than 1";
        } else {
            $this->errorMessage = "";
        }
    }
};
?>

<div>
    <p>Clicked times: <span class= "{{ $count >= 5000 ? "red" : ""  }}"> {{ $count }} </span></p>

    <button wire:click="increase">Increase</button>
    <button wire:click="reduce">Reduce</button>

    <p>{{ $errorMessage }}</p>

    <input type="number" min="1" wire:blur="validateAmount" wire:model.live="amount" />
    <p>Amount is {{ $amount }} </p>

    <style>
        .red {
            color: red;
        }
    </style>
</div>
