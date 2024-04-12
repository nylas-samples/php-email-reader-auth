<!Doctype html>
<html>
    <head>
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Email Reader</title>
    </head>
    <body>
        <table style="width:100%">
            <tr class="bg-green-600 border-green-600 border-b p-4 m-4 rounded">
                <th>Id</th>
                <th>Date</th>
                <th>Subject</th>
                <th>From Email</th>
            </tr>   
            @foreach ($emails as $email)
                <tr class="bg-white-600 border-green-600 border-b p-4 m-4 rounded">
                    <td><p class="text-sm font-semibold">{{$email->id}}</p></td>
                    <td><p class="text-sm font-semibold">{{$email->date}}</p></td>
                    <td><p class="text-sm font-semibold">{{$email->subject}}</p></td>
                    <td><p class="text-sm font-semibold">{{$email->from[0]->email}}</p></td>
                </tr>
            @endforeach
        </table><br>
        <div class="flex justify-center items-center">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded " type="button" onclick="window.location='/logout'">Log out</button>
        </div>
    </body>
</html> 
