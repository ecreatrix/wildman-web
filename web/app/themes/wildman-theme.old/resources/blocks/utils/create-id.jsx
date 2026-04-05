// Set the attributes to be displayed in the Background Options panel.
import { nanoid } from 'nanoid'

const buildID = ( prepend = '', length = 6 ) => {
	return prepend + nanoid( length )
}

export { buildID };