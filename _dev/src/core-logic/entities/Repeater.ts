import { ComponentContent } from "./ComponentContent";
import { REPEATER_TYPE } from "./ElementType";

export type Repeater<C extends ComponentContent> = {
  id: string;
  component_id: string;
  type: REPEATER_TYPE;
  label: string;
  sub_elements: C[];
};
