<x-layouts.app title="Dashboard">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <div class="col-md-12">

                <livewire:payment-summary />
            </div>
            <div class="col-md-4">
                <livewire:order-type-chart />
            </div>
            <div class="col-md-8">
                <livewire:top-items-report :limit="10" />
            </div>
        </div>
    </div>

</x-layouts.app>
