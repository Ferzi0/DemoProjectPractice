<?php

use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'orders' => Order::where('user_id', auth()->id())
                ->with('status')
                ->latest()
                ->get(),
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Мои заявки
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('orders.create') }}" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Создать заявку
                </a>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($orders->isEmpty())
                        <p class="text-gray-500">У вас пока нет заявок</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Адрес</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Вид ремонта</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата и время</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Способ оплаты</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->address }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->type }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $order->date->format('d.m.Y') }} {{ $order->time }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->payment }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($order->status->title === 'новая') bg-blue-100 text-blue-800
                                                    @elseif($order->status->title === 'в процессе') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status->title === 'завершена') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $order->status->title }}
                                                </span>
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