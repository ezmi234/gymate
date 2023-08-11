const button = document.querySelector('.follow-button');
const followers = document.querySelector('#followers');
button.addEventListener('click', async () => {
    const userId = button.getAttribute('data-user-id');
    const isFollowing = button.textContent.trim() === 'Unfollow';

    try {
        const response = await axios.post(`/users/${isFollowing ? 'unfollow' : 'follow'}/${userId}`);
        console.log(response.data.message);

        // Update button text
        button.textContent = isFollowing ? 'Follow' : 'Unfollow';
        if(isFollowing){
            button.classList.remove('btn-danger');
            button.classList.add('btn-primary');
            followers.textContent = parseInt(followers.textContent) - 1;
        } else {
            button.classList.remove('btn-primary');
            button.classList.add('btn-danger');
            followers.textContent = parseInt(followers.textContent) + 1;
        }
    } catch (error) {
        console.error(error);
    }
});

