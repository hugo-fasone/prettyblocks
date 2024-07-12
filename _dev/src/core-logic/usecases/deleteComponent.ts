import { findComponentById, findComponentByIdInBlock } from "../utils/finder";

import { CannotFindComponentError } from "../errors/CannotFindComponentError";

export const deleteComponentById = (zoneStore, componentId: string) => {
  const foundComponent = findComponentByIdInBlock(
    zoneStore.content[0],
    componentId
  );
  if (!foundComponent) {
    throw CannotFindComponentError(componentId);
  }
};
