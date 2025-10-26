import { ref } from 'vue';
import { useApiStore } from '../store/api';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export const useWishlist = () => {
    const api = useApiStore().api;
    const isInWishlist = ref(false);
    const addToWishlist = async (id) => {
        try {
            await api.post(`/wishlist/${id}`);
            isInWishlist.value = true;
            toast.success('Product added to wishlist', { autoClose: 2000 });
        } catch (error) {
            console.error('Error adding to wishlist:', error);
            toast.error('Failed to add to wishlist', { autoClose: 2000 });
        }
    };
    return { isInWishlist, addToWishlist };
}   