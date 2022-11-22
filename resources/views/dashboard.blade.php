<x-app-layout>
    <div style="height: calc(100vh - 64px);" class="w-screen h-screen p-3">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg h-full">
            <table class="w-full text-sm text-left text-gray-500 overflow-y-scroll max-h-full">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Date Requested
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Date Needed
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Area
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Customer Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Fleet No.
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Brand
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Supervisor
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Parts
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Service
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Rental
                        </th>
                        <th scope="col" class="py-3 px-6">
                            MRI
                        </th>
                        <th scope="col" class="py-3 px-6">
                            eDoc
                        </th>
                        <th scope="col" class="py-3 px-6">
                            DR
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Requester
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Request For
                        </th>
                        <th scope="col" class="py-3 px-6">
                            MRI Number
                        </th>
                        <th scope="col" class="py-3 px-6">
                            eDoc Number
                        </th>
                        <th scope="col" class="py-3 px-6">
                            DR Number
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($mrfs->count() > 0)
                        @foreach ($mrfs as $mrf)
                            <tr class="bg-white border-b">
                                <td class="py-4 px-6">
                                    <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->created_at->format('m-d-Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->date_needed->format('m-d-Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->area }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->customer_name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->fleet_no }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->brand_id }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->supervisor_id }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->parts }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->service }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->rental }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->mri }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->edoc }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->dr }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->requester }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->request_for }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->mri_no }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->edoc_no }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $mrf->dr_no }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b">
                            <td colspan="19"  class="py-4 px-6 text-center">
                                No Data.
                            </td>
                        </tr>
                    @endif


                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>
