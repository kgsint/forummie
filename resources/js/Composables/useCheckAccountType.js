export default (user) => {
    const isUser = () => {
        return user?.type === 'user'
    }
    const isAdmin = () => {
        return user?.type === 'admin'
    }
    const isModerator = () => {
        return user?.type === 'moderator'
    }

    return {
        isUser,
        isAdmin,
        isModerator,
    }
}
