import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { findComponentById } from "../utils/finder";

export const deleteComponentById = (zoneStore, componentId: string) => {
  const foundComponent = findComponentById(zoneStore.content, componentId);
  if (!foundComponent) {
    throw CannotFindComponentError(componentId);
  }
};
