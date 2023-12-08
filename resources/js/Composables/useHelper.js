export default ({ user }) => {
    const isUser = () => {
        return user?.type === 'user'
    }
    const isAdmin = () => {
        return user?.type === 'admin'
    }
    const isModerator = () => {
        return user?.type === 'moderator'
    }

    const convertToSlug = (str, seperator = "-") => {
        //replace all special characters | symbols with a space
        str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
        .toLowerCase();

        // trim spaces at start and end of string
        str = str.replace(/^\s+|\s+$/gm,'');
        // replace space with seperator
        str = str.replace(/\s+/g, seperator);

        return str;
    }

    return {
        isUser,
        isAdmin,
        isModerator,
        convertToSlug
    }
}
