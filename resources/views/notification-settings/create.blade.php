<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Notification') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('notificationSettings') }}">Notification Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <form method="POST" action="{{ route('notificationSettings:store') }}">
        @csrf

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">

                        <div class="py-6">
                            <p>
                                Setup a notification.
                            </p>

                            <div class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Email address</label>
                                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>


                            <div class="row">

                                <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="exampleFormControlSelect1">Category</label>
                                <select name="category" class="form-control" id="exampleFormControlSelect1">
                                    <option value="vulnerabilities">Vulnerabilities</option>
                                    <option value="credentials">Credentials</option>
                                    <option value="routes">Routes</option>
                                </select>
                            </div>
                                </div>

                                <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="exampleFormControlSelect1">Comparison</label>
                                <select name="comparison" class="form-control" id="exampleFormControlSelect1">
                                    <option>&lt;</option>
                                    <option>&lt;&equals;</option>
                                    <option>&equals;</option>
                                    <option>&gt;</option>
                                    <option>&gt;&equals;</option>
                                </select>
                            </div>
                                </div>

                                <div class="col">

                            <div class="form-group">
                                <label class="form-label">Numeric Amount</label>
                                <select name="amount" class="form-control" id="exampleFormControlSelect1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('notificationSettings') }}" class="btn btn-outline-secondary"><i class="bi bi-chevron-double-left"></i> Back</a>
    <button type="submit" class="btn btn-primary text-white"><i class="bi bi-plus"></i> Create Notification</button>
    </form>

</x-app-layout>
