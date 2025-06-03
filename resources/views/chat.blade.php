@extends('dashboard.layouts.main')

@section('content')
<div class="col d-flex align-items-stretch">
  <div class="card w-100 overflow-hidden rounded-4">
    <div class="card-body position-relative p-0">
      <div class="row g-0">

        <!-- Sidebar -->
        <div class="col-md-4 border-end" style="height: 500px; overflow-y: auto;">
          <div class="p-3 border-bottom">
            <h5>Daftar Chat</h5>
          </div>
          <ul class="list-group list-group-flush" id="chatList">
            @foreach($chats as $chat)
              <li class="list-group-item list-group-item-action"
                  data-incoming-msg-id="{{ $chat['id'] }}"
                  data-name="{{ $chat['name'] }}"
                  onclick="openChat(this)">
                <div class="d-flex align-items-center">
                  <div class="avatar bg-primary text-white rounded-circle me-2"
                       style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                    {{ strtoupper(substr($chat['name'], 0, 2)) }}
                  </div>
                  <div>
                    <div class="fw-bold">{{ $chat['name'] }}</div>
                    <div class="text-muted small">
                      {{ \Illuminate\Support\Str::limit($chat['last_chat']['msg'] ?? 'Belum ada pesan.', 30) }}
                    </div>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>

        <!-- Chat content -->
        <div class="col-md-8 d-flex flex-column" style="height: 500px;">
          <div class="p-3 border-bottom">
            <h5 id="chatTitle">Pilih chat</h5>
          </div>
          <div class="flex-grow-1 p-3" id="chatMessages" style="overflow-y: auto;"></div>
          <div class="p-3 border-top">
            <form id="chatForm" onsubmit="sendMessage(event)">
              <div class="input-group">
                <input type="text" id="messageInput" class="form-control" placeholder="Ketik pesan..." autocomplete="off">
                <button class="btn btn-primary" type="submit">Kirim</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let currentIncomingMsgId = null;
  let currentChatName = '';
  const currentUserId = {{ session('user.id') }};
  const token = '{{ session('token') }}';

  function openChat(listItem) {
    const incomingMsgId = listItem.getAttribute('data-incoming-msg-id');
    const name = listItem.getAttribute('data-name');

    currentIncomingMsgId = incomingMsgId;
    currentChatName = name;
    console.log('openChat', 'incomingMsgId', incomingMsgId, 'nama lawan bicara', name);
    document.getElementById('chatTitle').innerText = 'Chat dengan ' + name;
    const messageContainer = document.getElementById('chatMessages');
    messageContainer.innerHTML = '<div class="text-muted">Memuat pesan...</div>';

    // Ambil chat dari API
    fetch(`http://127.0.0.1:3000/api/room/${incomingMsgId}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
    .then(response => response.json())
    .then(data => {
      messageContainer.innerHTML = '';

      if (data.status === 'success' && data.data.length > 0) {
        data.data.forEach(chat => {
          const isFromUser = (chat.outgoing_msg_id == currentUserId);
          const alignClass = isFromUser ? 'text-end' : 'text-start';
          const badgeClass = isFromUser ? 'bg-primary' : 'bg-secondary';
          const senderName = isFromUser ? 'Saya' : currentChatName;

          messageContainer.innerHTML += `
            <div class="mb-2 ${alignClass}">
              <small class="d-block text-muted">${senderName}</small>
              <span class="badge ${badgeClass}">${chat.msg}</span>
            </div>
          `;
        });

      } else {
        messageContainer.innerHTML = '<div class="text-muted">Tidak ada pesan.</div>';
      }

      messageContainer.scrollTop = messageContainer.scrollHeight;
    })
    .catch(error => {
      console.error('Error fetching chat:', error);
      messageContainer.innerHTML = '<div class="text-danger">Gagal memuat pesan.</div>';
    });
  }

  function sendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    if (message === '' || !currentIncomingMsgId) return;

    const messageContainer = document.getElementById('chatMessages');

    // Kirim pesan ke API
    fetch(`http://127.0.0.1:3000/api/kirim_chat`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        receiver_id: currentIncomingMsgId,
        message: message
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        // Tampilkan pesan langsung
        messageContainer.innerHTML += `
          <div class="mb-2 text-start">
            <small class="d-block text-muted">Saya</small>
            <span class="badge bg-secondary">${message}</span>
          </div>
        `;
        messageContainer.scrollTop = messageContainer.scrollHeight;
        input.value = '';
      } else {
        alert('Gagal mengirim pesan.');
      }
    })
    .catch(error => {
      console.error('Error sending message:', error);
      alert('Terjadi kesalahan saat mengirim pesan.');
    });
  }
</script>
@endsection


