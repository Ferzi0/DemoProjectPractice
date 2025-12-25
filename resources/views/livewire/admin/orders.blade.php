<?php

use App\Models\Order;
use App\Models\Status;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'orders' => Order::with(['user', 'status'])->latest()->get(),
            'statuses' => Status::all(),
        ];
    }

    public function updateStatus($orderId, $statusId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status_id' => $statusId]);
        
        session()->flash('success', 'Статус заявки обновлен');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Панель администратора - Все заявки
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($orders->isEmpty())
                        <p class="text-gray-500">Заявок пока нет</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ФИО</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Телефон</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Адрес</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Вид ремонта</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата и время</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Оплата</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-4 py-4 text-sm">{{ $order->user->fullName() }}</td>
                                            <td class="px-4 py-4 text-sm">{{ $order->user->tel }}</td>
                                            <td class="px-4 py-4 text-sm">{{ $order->user->email }}</td>
                                            <td class="px-4 py-4 text-sm">{{ $order->address }}</td>
                                            <td class="px-4 py-4 text-sm">{{ $order->type }}</td>
                                            <td class="px-4 py-4 text-sm">
                                                {{ $order->date->format('d.m.Y') }} {{ $order->time }}
                                            </td>
                                            <td class="px-4 py-4 text-sm">{{ $order->payment }}</td>
                                            <td class="px-4 py-4 text-sm">
                                                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 text-sm">
                                                    @foreach($statuses as $status)
                                                        <option value="{{ $status->id }}" 
                                                            @selected($order->status_id === $status->id)>
                                                            {{ $status->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>