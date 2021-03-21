<?php

namespace Xuma\SideSelect;

use Livewire\Component;

class SideSelect extends Component
{
    public $model;

    public $label;

    public $tracker;

    public $items = [];

    public $selected = [];

    public $notSelected = [];

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
            return $item['id'] === $move;
        });

        $source = array_filter($source, function ($item) use ($move) {
            return $item['id'] !== $move;
        });

        if (reset($item)) {
            $target[] = reset($item);
        }
    }

    public function selectAll()
    {
        $this->selected = $this->items;
        $this->notSelected = [];
    }

    public function deselectAll()
    {
        $this->notSelected = $this->items;
        $this->selected = [];
    }

    public function render()
    {
        return view('sideselect::side-select');
    }
}