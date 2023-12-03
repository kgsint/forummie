import { onMounted, onUnmounted } from "vue"

export default (templateRef, callback) => {
    // to observe intersect
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            // if view point els are intersecting
            if(entry.isIntersecting) {
                // to do or action
                callback()
            }
        })
    })
    // load more data when intersect
    onMounted(() => {
        observer.observe(templateRef.value)
    })

    // disconnect when component unmount
    onUnmounted(() => {
        observer.disconnect()
    })
}
