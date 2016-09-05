<script>
    $("#multi-users").mention({
        queryBy: ['username'],
        users: [
        @foreach($users as $user)
            {
                username: "{{ $user->name }}",
                image: "{{ $user->image != '' ? url('/uploads/'.$user->image) : url('/images/profile2.png') }}"
            },
        @endforeach
        ]
    });
</script>