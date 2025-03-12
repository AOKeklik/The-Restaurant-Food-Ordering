<p><span>Name:</span> <span class="name fw-normal">{{ Auth::guard("user")->user()->name }}</span></p>
<p><span>Email:</span> {{ Auth::guard("user")->user()->email }}</p>