<?php

use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public $address = '';
    public $type = '';
    public $date = '';
    public $time = '';
    public $payment = '';

    public function save()
    {
        $validated = $this->validate([
            'address' => 'required|string|max:255',
            'type' => 'required|in:косметический ремонт,капитальный ремонт,электромонтаж',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'payment' => 'required|in:наличными,банковская карта,безналичный расчет',
        ]);

        Order::create([
            'address' => $validated['address'],
            'type' => $validated['type'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'payment' => $validated['payment'],
            'user_id' => auth()->id(),
            'status_id' => 1, // новая
        ]);

        $this->reset();
        session()->flash('success', 'Заявка успешно создана!');
        $this->redirect(route('orders.index'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Создать заявку
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit="save" class="space-y-6">
                        <div>
                            <label for="address" class="block text-sm font-medium">Адрес объекта ремонта</label>
                            <input type="text" id="address" wire:model="address" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('address') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium">Тип ремонта</label>
                            <select id="type" wire:model="type" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Выберите тип</option>
                                <option value="косметический ремонт">Косметический ремонт</option>
                                <option value="капитальный ремонт">Капитальный ремонт</option>
                                <option value="электромонтаж">Электромонтаж</option>
                            </select>
                            @error('type') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium">Дата начала работ</label>
                            <input type="date" id="date" wire:model="date" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium">Время начала работ</label>
                            <input type="time" id="time" wire:model="time" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('time') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="payment" class="block text-sm font-medium">Способ оплаты</label>
                            <select id="payment" wire:model="payment" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Выберите способ</option>
                                <option value="наличными">Наличными</option>
                                <option value="банковская карта">Банковская карта</option>
                                <option value="безналичный расчет">Безналичный расчет</option>
                            </select>
                            @error('payment') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Создать заявку
                            </button>
                            <a href="{{ route('orders.index') }}" 
                                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>