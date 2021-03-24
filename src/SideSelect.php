<?php

namespace Xuma\SideSelect;

use Illuminate\Support\Collection;
use Livewire\Component;

class SideSelect extends Component
{
    public string $model;

    public string $label;

    public string $tracker;

    public array $items = [];

    public array $selected = [];

    public array $notSelected = [];

    public string $notSelectedKeyword = '';

    public string $selectedKeyword = '';

    public function mount()
    {
        $builder = $this->model;
        $model  = $builder::query();
        $this->notSelected = $this->items = $model->get([$this->tracker, $this->label])->toArray();
    }

    public function select($id): void
    {
        $this->moveItems($this->notSelected, $this->selected, $id);
    }

    public function deselect($id): void
    {
        $this->moveItems($this->selected, $this->notSelected, $id);
    }

    /**
     * Moves items between arrays.
     *
     * @param array $source
     * @param array $target
     * @param int $move
     * @return void
     */
    private function moveItems(array &$source, array &$target, int $move): void
    {
        $item = array_filter($source, function ($item) use ($move) {
            return $item[$this->tracker] === $move;
        });

        $source = array_filter($source, function ($item) use ($move) {
            return $item[$this->tracker] !== $move;
        });

        if (reset($item)) {
            $target[] = reset($item);
        }
    }

    public function selectAll(): void
    {
        $this->selected = $this->items;
        $this->notSelected = [];
    }

    public function deselectAll(): void
    {
        $this->notSelected = $this->items;
        $this->selected = [];
    }

    public function render()
    {
        $this->notSelected = $this->search($this->notSelectedKeyword, $this->items)->filter(function ($item) {
            return !in_array($item[$this->tracker], array_column($this->selected, $this->tracker), true);
        })->toArray();

        $this->selected = collect($this->selected)->map(function ($item) {
            $item['shown'] = true;

            if ($this->selectedKeyword !== '' && !str_contains(strtolower($item[$this->label]), strtolower($this->selectedKeyword))) {
                $item['shown'] = false;
            }

            return $item;
        })->toArray();

        return view('sideselect::side-select');
    }

    private function search($keyword, $collection): Collection
    {
        return collect($collection)->filter(function ($item) use ($keyword) {
            if ($keyword === '' || str_contains(strtolower($item[$this->label]), strtolower($keyword))) {
                return $item;
            }
        });
    }
}